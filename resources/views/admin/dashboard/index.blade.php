@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('styles')
<style>
    .stat-card {
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(255, 255, 255, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 10;
    }
    .loader {
        border: 3px solid #f3f3f3;
        border-top: 3px solid #3498db;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endsection

@section('content')
<div class="container mx-auto">
    <!-- Main dashboard content -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8" id="stats-container">
        <!-- Stats cards will be loaded here -->
        <div class="col-span-1 bg-white rounded-lg shadow p-6 relative stat-card">
            <div class="loading-overlay">
                <div class="loader"></div>
            </div>
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-500 bg-opacity-75 text-white">
                    <i class="fas fa-user-graduate text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500 uppercase font-semibold">Total Students</p>
                    <p class="text-2xl font-bold text-gray-800" id="total-students">--</p>
                </div>
            </div>
        </div>
        
        <div class="col-span-1 bg-white rounded-lg shadow p-6 relative stat-card">
            <div class="loading-overlay">
                <div class="loader"></div>
            </div>
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-500 bg-opacity-75 text-white">
                    <i class="fas fa-book text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500 uppercase font-semibold">Total Programs</p>
                    <p class="text-2xl font-bold text-gray-800" id="total-programs">--</p>
                </div>
            </div>
        </div>
        
        <div class="col-span-1 bg-white rounded-lg shadow p-6 relative stat-card">
            <div class="loading-overlay">
                <div class="loader"></div>
            </div>
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-500 bg-opacity-75 text-white">
                    <i class="fas fa-chalkboard text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500 uppercase font-semibold">Total Courses</p>
                    <p class="text-2xl font-bold text-gray-800" id="total-courses">--</p>
                </div>
            </div>
        </div>
        
        <div class="col-span-1 bg-white rounded-lg shadow p-6 relative stat-card">
            <div class="loading-overlay">
                <div class="loader"></div>
            </div>
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-500 bg-opacity-75 text-white">
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500 uppercase font-semibold">Active Term</p>
                    <p class="text-2xl font-bold text-gray-800" id="active-term">--</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Upcoming Exams Section -->
        <div class="bg-white rounded-lg shadow relative">
            <div class="loading-overlay">
                <div class="loader"></div>
            </div>
            <div class="border-b px-6 py-3">
                <h3 class="text-lg font-medium text-gray-900">Upcoming Exams</h3>
            </div>
            <div class="p-6" id="upcoming-exams-container">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date/Time</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="upcoming-exams-body">
                        <!-- Exams will be loaded here -->
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Loading exams...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Recent Announcements Section -->
        <div class="bg-white rounded-lg shadow relative">
            <div class="loading-overlay">
                <div class="loader"></div>
            </div>
            <div class="border-b px-6 py-3">
                <h3 class="text-lg font-medium text-gray-900">Recent Announcements</h3>
            </div>
            <div class="p-6" id="recent-announcements-container">
                <div id="announcements-list">
                    <!-- Announcements will be loaded here -->
                    <p class="text-center text-gray-500">Loading announcements...</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 mb-8">
        <!-- User Registration Chart -->
        <div class="bg-white rounded-lg shadow p-6 relative">
            <div class="loading-overlay">
                <div class="loader"></div>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-4">User Registration Trends</h3>
            <div class="h-72">
                <canvas id="registration-chart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fetch dashboard data from the API
    fetchDashboardData();
    
    // Setup refresh timer (every 5 minutes)
    setInterval(fetchDashboardData, 300000);
    
    // Format date function
    function formatDate(dateString) {
        const options = { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
        return new Date(dateString).toLocaleDateString('en-US', options);
    }
    
    function fetchDashboardData() {
        // Fetch dashboard data from API
        axios.get('/admin/dashboard')
            .then(response => {
                const data = response.data;
                
                // Update stats
                document.getElementById('total-students').textContent = data.stats.total_students;
                document.getElementById('total-programs').textContent = data.stats.total_programs;
                document.getElementById('total-courses').textContent = data.stats.total_courses;
                
                // Update active term
                if (data.currentTerm) {
                    document.getElementById('active-term').textContent = data.currentTerm.name;
                } else {
                    document.getElementById('active-term').textContent = 'None';
                }
                
                // Hide all loading overlays
                document.querySelectorAll('.loading-overlay').forEach(overlay => {
                    overlay.style.display = 'none';
                });
                
                // Populate upcoming exams
                populateUpcomingExams(data.upcomingExams);
                
                // Populate recent announcements
                populateRecentAnnouncements(data.recentAnnouncements);
                
                // Create registration chart if data is available
                if (data.userTrends) {
                    createRegistrationChart(data.userTrends);
                }
            })
            .catch(error => {
                console.error('Error fetching dashboard data:', error);
                
                // Hide loading overlays and show error messages
                document.querySelectorAll('.loading-overlay').forEach(overlay => {
                    overlay.style.display = 'none';
                });
                
                // Show error message
                const errorHtml = `
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline">Unable to load dashboard data. Please try again later.</span>
                    </div>
                `;
                
                document.getElementById('stats-container').insertAdjacentHTML('beforebegin', errorHtml);
            });
    }
    
    function populateUpcomingExams(exams) {
        const container = document.getElementById('upcoming-exams-body');
        
        if (!exams || exams.length === 0) {
            container.innerHTML = `
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">No upcoming exams found</td>
                </tr>
            `;
            return;
        }
        
        let html = '';
        exams.forEach(exam => {
            html += `
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${exam.title}</div>
                        <div class="text-xs text-gray-500">${exam.exam_type}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">${exam.course ? exam.course.name : 'N/A'}</div>
                        <div class="text-xs text-gray-500">${exam.section ? 'Section ' + exam.section.name : 'All Sections'}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">${formatDate(exam.start_datetime)}</div>
                        <div class="text-xs text-gray-500">Duration: ${exam.duration_minutes} mins</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="/admin/exams/${exam.id}" class="text-indigo-600 hover:text-indigo-900">View</a>
                    </td>
                </tr>
            `;
        });
        
        container.innerHTML = html;
    }
    
    function populateRecentAnnouncements(announcements) {
        const container = document.getElementById('announcements-list');
        
        if (!announcements || announcements.length === 0) {
            container.innerHTML = `<p class="text-center text-gray-500">No recent announcements found</p>`;
            return;
        }
        
        let html = '';
        announcements.forEach(announcement => {
            html += `
                <div class="mb-4 pb-4 border-b border-gray-200 last:border-0 last:mb-0 last:pb-0">
                    <h4 class="text-md font-medium text-gray-900 mb-1">${announcement.title}</h4>
                    <p class="text-sm text-gray-600 mb-2">${announcement.content.substring(0, 100)}${announcement.content.length > 100 ? '...' : ''}</p>
                    <div class="flex justify-between items-center text-xs text-gray-500">
                        <span>By: ${announcement.author ? announcement.author.name : 'System'}</span>
                        <span>${formatDate(announcement.created_at)}</span>
                    </div>
                </div>
            `;
        });
        
        container.innerHTML = html;
    }
    
    function createRegistrationChart(trends) {
        const ctx = document.getElementById('registration-chart').getContext('2d');
        
        // Create chart
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: trends.labels,
                datasets: [{
                    label: 'New Users',
                    data: trends.data,
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                }
            }
        });
    }
});
</script>
@endsection
