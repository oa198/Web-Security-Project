@extends('layouts.admin')

@section('title', 'Academic Calendar')
@section('page-title', 'Academic Calendar')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.min.css" rel="stylesheet">
<style>
    .calendar-container {
        height: 700px;
    }
    .fc-event {
        cursor: pointer;
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
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Academic Calendar</h2>
        
        @can('create', App\Models\AcademicCalendar::class)
        <div class="flex space-x-2">
            <button type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md" 
                id="create-event-btn" data-modal="create-event-modal">
                <i class="fas fa-plus mr-2"></i> Add Event
            </button>
            <button type="button" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md" 
                id="bulk-create-btn" data-modal="bulk-create-modal">
                <i class="fas fa-list-check mr-2"></i> Bulk Create
            </button>
        </div>
        @endcan
    </div>
    
    <!-- Alert Messages -->
    <div id="alert-container" class="mb-6"></div>
    
    <!-- Filter Section -->
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="filter-term" class="block text-sm font-medium text-gray-700">Academic Term</label>
                <select id="filter-term" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Terms</option>
                    <!-- Terms will be populated via JS -->
                </select>
            </div>
            <div>
                <label for="filter-event-type" class="block text-sm font-medium text-gray-700">Event Type</label>
                <select id="filter-event-type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Types</option>
                    <option value="class">Class Period</option>
                    <option value="registration">Registration</option>
                    <option value="exam">Exam Period</option>
                    <option value="holiday">Holiday</option>
                    <option value="event">Campus Event</option>
                    <option value="deadline">Deadline</option>
                </select>
            </div>
            <div>
                <label for="filter-visibility" class="block text-sm font-medium text-gray-700">Visibility</label>
                <select id="filter-visibility" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All</option>
                    <option value="public">Public</option>
                    <option value="staff">Staff</option>
                    <option value="students">Students</option>
                    <option value="faculty">Faculty</option>
                </select>
            </div>
        </div>
    </div>
    
    <!-- Calendar View -->
    <div class="bg-white rounded-lg shadow relative">
        <div id="loading-overlay" class="loading-overlay">
            <div class="loader"></div>
        </div>
        
        <div class="p-4 calendar-container" id="calendar"></div>
    </div>
</div>

<!-- Create Event Modal -->
<div id="create-event-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        
        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-gray-50 px-4 py-3 border-b">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900" id="modal-title">
                        Add Calendar Event
                    </h3>
                    <button type="button" class="close-modal text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Close</span>
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <form id="create-event-form">
                <div class="p-6 space-y-4">
                    <div>
                        <label for="academic_term_id" class="block text-sm font-medium text-gray-700">Academic Term</label>
                        <select id="academic_term_id" name="academic_term_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="">Select Term</option>
                            <!-- Terms will be populated via JS -->
                        </select>
                        <span class="text-red-500 text-xs error-message" id="academic_term_id-error"></span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="event_type" class="block text-sm font-medium text-gray-700">Event Type</label>
                            <select id="event_type" name="event_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="">Select Type</option>
                                <option value="class">Class Period</option>
                                <option value="registration">Registration</option>
                                <option value="exam">Exam Period</option>
                                <option value="holiday">Holiday</option>
                                <option value="event">Campus Event</option>
                                <option value="deadline">Deadline</option>
                            </select>
                            <span class="text-red-500 text-xs error-message" id="event_type-error"></span>
                        </div>
                        <div>
                            <label for="visibility" class="block text-sm font-medium text-gray-700">Visibility</label>
                            <select id="visibility" name="visibility" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="public">Public</option>
                                <option value="staff">Staff Only</option>
                                <option value="students">Students Only</option>
                                <option value="faculty">Faculty Only</option>
                            </select>
                            <span class="text-red-500 text-xs error-message" id="visibility-error"></span>
                        </div>
                    </div>
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Event Name</label>
                        <input type="text" id="name" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <span class="text-red-500 text-xs error-message" id="name-error"></span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                            <input type="date" id="start_date" name="start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <span class="text-red-500 text-xs error-message" id="start_date-error"></span>
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                            <input type="date" id="end_date" name="end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <span class="text-red-500 text-xs error-message" id="end_date-error"></span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                            <input type="time" id="start_time" name="start_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <span class="text-red-500 text-xs error-message" id="start_time-error"></span>
                        </div>
                        <div>
                            <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                            <input type="time" id="end_time" name="end_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <span class="text-red-500 text-xs error-message" id="end_time-error"></span>
                        </div>
                    </div>
                    
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700">Location (optional)</label>
                        <input type="text" id="location" name="location" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <span class="text-red-500 text-xs error-message" id="location-error"></span>
                    </div>
                    
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        <span class="text-red-500 text-xs error-message" id="description-error"></span>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="is_holiday" name="is_holiday" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_holiday" class="ml-2 block text-sm text-gray-700">
                                Holiday
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="is_campus_closed" name="is_campus_closed" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_campus_closed" class="ml-2 block text-sm text-gray-700">
                                Campus Closed
                            </label>
                        </div>
                    </div>
                    
                    <div>
                        <label for="color_code" class="block text-sm font-medium text-gray-700">Color (optional)</label>
                        <input type="color" id="color_code" name="color_code" class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>
                
                <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end space-x-2">
                    <button type="button" class="close-modal bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-md">
                        Cancel
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Save Event
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View/Edit Event Modal (will be populated dynamically) -->
<div id="view-event-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Similar structure to create modal, but with edit/delete buttons -->
</div>

@endsection

@section('scripts-head')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.min.js"></script>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize calendar
    initCalendar();
    
    // Load academic terms for filters and form
    loadAcademicTerms();
    
    // Setup filter listeners
    document.getElementById('filter-term').addEventListener('change', applyFilters);
    document.getElementById('filter-event-type').addEventListener('change', applyFilters);
    document.getElementById('filter-visibility').addEventListener('change', applyFilters);
    
    // Form submission handler for creating an event
    document.getElementById('create-event-form').addEventListener('submit', function(e) {
        e.preventDefault();
        createEvent();
    });
    
    let calendar;
    
    function initCalendar() {
        const calendarEl = document.getElementById('calendar');
        
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listMonth'
            },
            events: fetchEvents,
            eventClick: handleEventClick,
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                meridiem: 'short'
            },
            loading: function(isLoading) {
                if (isLoading) {
                    document.getElementById('loading-overlay').style.display = 'flex';
                } else {
                    document.getElementById('loading-overlay').style.display = 'none';
                }
            }
        });
        
        calendar.render();
    }
    
    function fetchEvents(info, successCallback, failureCallback) {
        // Get filter values
        const termId = document.getElementById('filter-term').value;
        const eventType = document.getElementById('filter-event-type').value;
        const visibility = document.getElementById('filter-visibility').value;
        
        // Build query parameters
        let queryParams = `?start=${info.startStr}&end=${info.endStr}`;
        if (termId) queryParams += `&academic_term_id=${termId}`;
        if (eventType) queryParams += `&event_type=${eventType}`;
        if (visibility) queryParams += `&visibility=${visibility}`;
        
        // Fetch events from API
        axios.get(`/admin/academic-calendars${queryParams}`)
            .then(response => {
                // Transform API response into FullCalendar event objects
                const events = response.data.map(event => ({
                    id: event.id,
                    title: event.name,
                    start: event.start_date + (event.start_time ? 'T' + event.start_time : ''),
                    end: event.end_date ? (event.end_date + (event.end_time ? 'T' + event.end_time : '')) : null,
                    allDay: !event.start_time,
                    color: event.color_code || getEventTypeColor(event.event_type),
                    extendedProps: {
                        event_type: event.event_type,
                        location: event.location,
                        description: event.description,
                        is_holiday: event.is_holiday,
                        is_campus_closed: event.is_campus_closed,
                        visibility: event.visibility,
                        academic_term: event.academic_term ? event.academic_term.name : null
                    }
                }));
                
                successCallback(events);
            })
            .catch(error => {
                console.error('Error fetching events:', error);
                failureCallback(error);
                
                // Show error message
                showAlert('error', 'Failed to load calendar events. Please try again later.');
            });
    }
    
    function getEventTypeColor(eventType) {
        // Default colors based on event type
        const colors = {
            'class': '#4285F4',
            'registration': '#34A853',
            'exam': '#EA4335',
            'holiday': '#FBBC05',
            'event': '#9C27B0',
            'deadline': '#FF6D00'
        };
        
        return colors[eventType] || '#3788d8';
    }
    
    function handleEventClick(info) {
        // Display event details in the view modal
        console.log('Event clicked:', info.event);
        
        // Implementation for viewing/editing event details
        // This would show the view-event-modal with event details
        // and allow editing if the user has permission
    }
    
    function loadAcademicTerms() {
        // Fetch academic terms from API
        axios.get('/admin/academic-terms')
            .then(response => {
                const terms = response.data.data;
                
                // Populate term dropdowns
                populateTermDropdown('filter-term', terms);
                populateTermDropdown('academic_term_id', terms);
            })
            .catch(error => {
                console.error('Error fetching academic terms:', error);
                showAlert('error', 'Failed to load academic terms. Please try again later.');
            });
    }
    
    function populateTermDropdown(elementId, terms) {
        const dropdown = document.getElementById(elementId);
        
        // Clear existing options except the first one
        while (dropdown.options.length > 1) {
            dropdown.remove(1);
        }
        
        // Add term options
        terms.forEach(term => {
            const option = document.createElement('option');
            option.value = term.id;
            option.textContent = term.name;
            
            // Mark active term
            if (term.is_active) {
                option.textContent += ' (Active)';
                
                // Select active term by default
                if (elementId === 'academic_term_id') {
                    option.selected = true;
                }
            }
            
            dropdown.appendChild(option);
        });
    }
    
    function applyFilters() {
        // Refresh the calendar with new filters
        calendar.refetchEvents();
    }
    
    function createEvent() {
        // Reset error messages
        document.querySelectorAll('.error-message').forEach(el => {
            el.textContent = '';
        });
        
        // Get form data
        const formData = new FormData(document.getElementById('create-event-form'));
        const eventData = Object.fromEntries(formData.entries());
        
        // Convert checkboxes to boolean
        eventData.is_holiday = formData.has('is_holiday');
        eventData.is_campus_closed = formData.has('is_campus_closed');
        
        // Create event via API
        axios.post('/admin/academic-calendars', eventData)
            .then(response => {
                // Close modal
                document.getElementById('create-event-modal').classList.add('hidden');
                
                // Show success message
                showAlert('success', 'Calendar event created successfully!');
                
                // Refresh calendar
                calendar.refetchEvents();
                
                // Reset form
                document.getElementById('create-event-form').reset();
            })
            .catch(error => {
                console.error('Error creating event:', error);
                
                if (error.response && error.response.data && error.response.data.errors) {
                    // Display validation errors
                    const errors = error.response.data.errors;
                    Object.keys(errors).forEach(field => {
                        const errorElement = document.getElementById(`${field}-error`);
                        if (errorElement) {
                            errorElement.textContent = errors[field][0];
                        }
                    });
                } else {
                    // Show general error
                    showAlert('error', 'Failed to create calendar event. Please try again.');
                }
            });
    }
    
    // Function to show an alert message
    function showAlert(type, message) {
        const alertContainer = document.getElementById('alert-container');
        
        const alertClass = type === 'success' 
            ? 'bg-green-100 border-green-400 text-green-700' 
            : 'bg-red-100 border-red-400 text-red-700';
            
        const alertHtml = `
            <div class="${alertClass} px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">${message}</span>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
                    <span class="sr-only">Close</span>
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        alertContainer.innerHTML = alertHtml;
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            const alert = alertContainer.querySelector('div[role="alert"]');
            if (alert) {
                alert.remove();
            }
        }, 5000);
    }
});
</script>
@endsection
